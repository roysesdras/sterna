<style>
    /* Animation personnalisée pour l'image */
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(20px); }
    }
    .animate-float {
      animation: float 4s ease-in-out infinite;
    }
  </style>

<main class="w-full min-h-screen bg-[url('https://i.postimg.cc/NjpVzqsW/main-bg-recolor-sterna-bleu.png')] bg-cover bg-center py-16 flex items-center justify-center">
    
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-10">
      
      <!-- Texte -->
      <section class="flex-1 text-white">
        <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">
          STERNA AFRICA <br>WHEREVER NEEDED 
        </h1>
        <p class="text-lg md:text-xl text-blue-200">
          Nous sommes partout où le besoin se fait sentir, nous sommes une association d'ECSI
        </p>
      </section>

      <!-- Image -->
      <div class="flex-1 flex justify-center md:justify-end">
        <img src="https://i.ibb.co/MD9zmRRC/1755464569925.jpg" 
            alt="NGO Image" 
            class="w-full max-w-[600px] h-[300px] sm:h-[400px] md:h-[550px] object-cover rounded-[20%] shadow-3xl animate-float">
      </div>

    </div>
  </main>