 <!-- Popup -->
    <style>
     .popup{display:none;position:fixed;left:0;top:0;width:100%;height:100%;overflow:hidden;z-index:1000;background-color:rgba(0, 0, 0, 0.5)}.popup-overlay{position:fixed;left:0;top:0;width:100%;height:100%;background-color:rgba(0, 0, 0, 0.7);z-index:999}.popup-content{position:relative;background:#fff;margin:5% auto;padding:20px;width:80%;max-width:500px;border-radius:5px;box-shadow:rgba(0, 0, 0, 0.35) 0 5px 15px;z-index:1000;overflow:hidden}.popup-image{height:auto;margin-bottom:10px}.popup-button{display:inline-block;padding:10px 20px;font-size:16px;color:#fff;background-color:#305196;text-decoration:none;border-radius:4px}.popup-button:hover{background-color:#fff;border:#305196 1px solid;color:#305196}.close-btn{position:absolute;top:-25px;right:3px;font-size:45px;font-weight:bold;color:#aaa;cursor:pointer}.close-btn:hover{color:#000}
    </style>
 
 
    <div id="popup" class="popup">
        <div class="popup-content comic-neue-regular">
            <span id="close-btn" class="close-btn">&times;</span>
            <img src="https://i.postimg.cc/432VBhzR/sel.jpg" alt="Popup Image" class="w-100">
            <p>Imaginez un monde où une coopérative de femmes peut voir ses conditions de vie et de travail s'améliorer grâce à vous. Joignez-vous à nous pour soutenir et encourager l'autonomisation des vaillantes femmes d'Avlo (Bénin) dans la production et la vente de sel.</p>
            <a href="https://www.helloasso.com/associations/echanges-solidarite/collectes/mission-solidaire-au-benin-2024" target="_blanck" class="popup-button comic-neue-bold">Agissons ensemble</a>
        </div>
        <div class="popup-overlay"></div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const popup = document.getElementById("popup");
            const closeBtn = document.getElementById("close-btn");

            function openPopup() {
                popup.style.display = "block";
                document.body.style.overflow = "hidden"; // Disable page scroll
            }

            function closePopup() {
                popup.style.display = "none";
                document.body.style.overflow = "auto"; // Re-enable page scroll
            }

            // Show the popup after 3 seconds
            setTimeout(openPopup, 5000); // 5000 milliseconds = 5 seconds

            // Close the popup when the close button is clicked
            closeBtn.addEventListener("click", closePopup);

            // Close the popup when clicking outside the content
            document.querySelector(".popup-overlay").addEventListener("click", closePopup);
        });


    </script>