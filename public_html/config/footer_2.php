    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Prend toute la hauteur de l'écran */
        }

        .container {
            flex: 1; /* Pousse le footer vers le bas */
        }

        .footer {
            background-color: #141421fd;
            text-align: center;
            padding: 10px 0;
            color: #fff;
            width: 100%; /* Assure que le footer prend toute la largeur */
        }
    </style>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <footer class="footer px-2 copyright comic-neue-regular">
    &copy;
        <script>
            document.write(new Date().getFullYear());
        </script>
         <strong><span> - Sterna-Africa International</span></strong>.
    </footer>