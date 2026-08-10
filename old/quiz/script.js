// ============================================
// SCRIPT DE LANCEMENT DES QUESTIONS
// ============================================
document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".lancer-btn");

  buttons.forEach((btn) => {
    btn.addEventListener("click", async function () {
      const questionId = this.dataset.questionId;
      this.disabled = true;
      this.textContent = "Lancement en cours...";

      try {
        const response = await fetch("lancer_question.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            question_id: questionId,
          }),
        });

        const result = await response.text();

        if (response.ok) {
          document.querySelectorAll(".lancer-btn").forEach((b) => {
            b.disabled = false;
            b.textContent = "Lancer cette question";
            b.classList.remove(
              "bg-stone-600",
              "cursor-not-allowed",
              "opacity-70",
            );
            b.classList.add("bg-purple-600", "hover:bg-purple-700");
          });

          this.disabled = true;
          this.textContent = "Question déjà lancée";
          this.classList.remove("bg-purple-600", "hover:bg-purple-700");
          this.classList.add(
            "bg-stone-600",
            "cursor-not-allowed",
            "opacity-70",
          );
        } else {
          alert("Erreur lors du lancement de la question.");
          this.disabled = false;
          this.textContent = "Lancer cette question";
        }
      } catch (error) {
        console.error(error);
        alert("Erreur de connexion au serveur.");
        this.disabled = false;
        this.textContent = "Lancer cette question";
      }
    });
  });
});

// ============================================
// TERMINER L'ANIMATION
// ============================================

document.addEventListener("DOMContentLoaded", () => {
  const btnTerminer = document.getElementById("btnTerminer");
  const btnTerminerMobile = document.getElementById("btnTerminerMobile");
  // const listeResultats = document.getElementById("listeResultats");

  const disableAllLaunchButtons = () => {
    const tousLesBoutons = document.querySelectorAll(".lancer-btn");
    tousLesBoutons.forEach((b) => {
      b.disabled = true;
      b.classList.remove("bg-purple-600", "hover:bg-purple-700");
      b.classList.add("bg-stone-600", "cursor-not-allowed", "opacity-70");
      b.textContent = "Session terminée";
    });
  };

  async function terminerAnimation() {
    if (!confirm("Voulez-vous vraiment terminer l'animation ?")) return;

    // Blocage visuel des boutons
    const btns = [
      document.getElementById("btnTerminer"),
      document.getElementById("btnTerminerMobile"),
    ];
    btns.forEach((b) => {
      if (b) {
        b.disabled = true;
        b.innerText = "Calcul...";
      }
    });

    try {
      const response = await fetch("terminer_quiz.php", {
        method: "POST",
        headers: { "X-Requested-With": "XMLHttpRequest" },
      });

      // On vérifie si le fichier existe (404) ou erreur serveur (500)
      if (!response.ok) {
        throw new Error(
          "Le fichier terminer_quiz.php est introuvable ou crashé (Erreur " +
            response.status +
            ")",
        );
      }

      const dataStatus = await response.json();

      if (dataStatus.status === "success") {
        console.log("Succès, redirection...");
        window.location.replace("classement-final"); // .replace est plus direct que .href
      } else {
        // Ici on saura si c'est un problème de session ou de SQL
        alert("Erreur Serveur : " + dataStatus.message);
        btns.forEach((b) => {
          if (b) {
            b.disabled = false;
            b.innerText = "Terminer l'animation";
          }
        });
      }
    } catch (error) {
      console.error("Erreur:", error);
      alert("Erreur critique : " + error.message);
      btns.forEach((b) => {
        if (b) {
          b.disabled = false;
          b.innerText = "Terminer l'animation";
        }
      });
    }
  }

  if (btnTerminer) {
    btnTerminer.addEventListener("click", (e) => {
      e.preventDefault();
      terminerAnimation();
    });
  }

  if (btnTerminerMobile) {
    btnTerminerMobile.addEventListener("click", (e) => {
      e.preventDefault();
      terminerAnimation();
    });
  }
});

// ============================================
// NAVIGATION ENTRE CATÉGORIES
// ============================================
document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll(".categorie-btn");
  const sections = document.querySelectorAll(".categorie-section");

  buttons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const targetId = btn.getAttribute("data-target");
      const target = document.getElementById(targetId);
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }

      buttons.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");
    });
  });
});
