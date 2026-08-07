<?php
// Autorise n'importe quel robot à lire ce fichier XML
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: text/xml; charset=UTF-8");

$site_url = "https://sternaafrica.org";
$feed_url = "https://sternaafrica.org/feed.xml"; // URL pour la balise atom

// 1. Connexion propre
$conn = new mysqli('db', 'root', 'SoftiP24', 'africa_db');
if ($conn->connect_error) die();
$conn->set_charset("utf8mb4");

$sql = "SELECT id, title, description, image, DATE_FORMAT(start_date, '%a, %d %b %Y %H:%i:%s GMT') as pubDate
        FROM actualites
        ORDER BY start_date DESC
        LIMIT 20";
$result = $conn->query($sql);

echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Sterna Africa - Actualités</title>
        <link><?= $site_url ?></link>
        <description>Les dernières actualités de Sterna Africa</description>
        <language>fr-fr</language>
        <lastBuildDate><?= date(DATE_RSS) ?></lastBuildDate>
        <atom:link href="<?= $feed_url ?>" rel="self" type="application/rss+xml" />

        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Correction Apostrophes : ENT_QUOTES | ENT_XML1 évite les codes HTML type &#039; dans le titre
                $title = htmlspecialchars($row['title'], ENT_XML1 | ENT_QUOTES, 'UTF-8');

                // Découpe propre en UTF-8
                $desc_plain = strip_tags($row['description']);
                if (mb_strlen($desc_plain) > 150) {
                    $desc_plain = mb_substr($desc_plain, 0, 147, 'UTF-8') . '...';
                }
                $desc_plain = htmlspecialchars($desc_plain, ENT_XML1, 'UTF-8');

                $link = $site_url . "/actualite/" . $row['id'];
                $image_url = $site_url . "/images/" . rawurlencode($row['image']);

                echo "  <item>\n";
                echo "    <title>$title</title>\n";
                echo "    <link>$link</link>\n";
                echo "    <description><![CDATA[<img src='$image_url' alt='' style='max-width:100%;' /><p>$desc_plain</p>]]></description>\n";
                echo "    <enclosure url='$image_url' length='50000' type='image/jpeg' />\n";
                echo "    <pubDate>{$row['pubDate']}</pubDate>\n";
                echo "    <guid isPermaLink='true'>$link</guid>\n";
                echo "  </item>\n";
            }
        }
        $conn->close();
        ?>
    </channel>
</rss>