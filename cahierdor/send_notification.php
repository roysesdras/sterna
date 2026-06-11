<?php
require_once 'includes/db.php';
require_once 'vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

function sendPushNotification($title, $body) {
    global $pdo;

    // Configuration des clés VAPID standard
    $auth = [
        'VAPID' => [
            'subject' => 'mailto:sternaafrica@gmail.com',
            'publicKey' => 'BFraVWz7Omh0DtS2AN3ZeGt1eVZDqAQjiaGmlabUxT-Bq0CEVM8vLstuB9iFTYJqS6b3oAgwBjOjKpy776ViUmY',
            'privateKey' => 'v8_hOOIw2HykKNunSA7ynUmVcOI4psZfi9DhLpUvfo0'
        ]
    ];

    // Récupérer les abonnements de la base de données
    $stmt = $pdo->query("SELECT token FROM notification_tokens");
    $tokens = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($tokens)) {
        return 0;
    }

    try {
        $webPush = new WebPush($auth);
        
        // Payload standard de notification
        $payload = json_encode([
            'title' => $title,
            'body' => $body,
            'icon' => 'https://cahierdor.sternaafrica.org/favicon/web-app-manifest-192x192.png',
            'url' => 'https://cahierdor.sternaafrica.org/'
        ]);

        $queuedCount = 0;
        $failedTokens = [];

        foreach ($tokens as $tokenString) {
            $subData = json_decode($tokenString, true);
            if (!$subData || !isset($subData['endpoint'])) {
                // Si ce n'est pas du JSON d'abonnement VAPID valide (ex: ancien token FCM legacy),
                // on l'ajoute à la liste pour suppression
                $failedTokens[] = $tokenString;
                continue;
            }

            $subscription = Subscription::create($subData);
            $webPush->queueNotification($subscription, $payload);
            $queuedCount++;
        }

        $successCount = 0;
        if ($queuedCount > 0) {
            foreach ($webPush->flush() as $report) {
                $endpoint = $report->getEndpoint();
                if ($report->isSuccess()) {
                    $successCount++;
                } else {
                    error_log("[VAPID WebPush] Echec pour {$endpoint} : {$report->getReason()}");
                    
                    // Si l'abonnement a expiré ou n'est plus valide (Gone/Expired)
                    if ($report->isSubscriptionExpired()) {
                        foreach ($tokens as $tokenString) {
                            if (strpos($tokenString, $endpoint) !== false) {
                                $failedTokens[] = $tokenString;
                            }
                        }
                    }
                }
            }
        }

        // Nettoyage automatique des abonnements obsolètes de la BDD
        if (!empty($failedTokens)) {
            $failedTokens = array_unique($failedTokens);
            $inQuery = implode(',', array_fill(0, count($failedTokens), '?'));
            $stmtDel = $pdo->prepare("DELETE FROM notification_tokens WHERE token IN ($inQuery)");
            $stmtDel->execute($failedTokens);
            error_log("[VAPID WebPush] Nettoyage automatique de " . count($failedTokens) . " abonnements invalides.");
        }

        return $successCount;

    } catch (Exception $e) {
        error_log("[VAPID WebPush] Exception lors de l'envoi : " . $e->getMessage());
        return 0;
    }
}
