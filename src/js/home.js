// Fonctionnalité pour basculer entre les vidéos et les packs
        document.querySelector('.lien-videos').addEventListener('click', function() {
            this.classList.add('active');
            document.querySelector('.lien-pack').classList.remove('active');
            
            // Afficher les vidéos, cacher les packs
            document.querySelectorAll('.videos').forEach(video => {
                video.style.display = 'block';
            });
            document.querySelectorAll('.pack').forEach(pack => {
                pack.style.display = 'none';
            });
        });
        
        document.querySelector('.lien-pack').addEventListener('click', function() {
            this.classList.add('active');
            document.querySelector('.lien-videos').classList.remove('active');
            
            // Afficher les packs, cacher les vidéos
            document.querySelectorAll('.videos').forEach(video => {
                video.style.display = 'none';
            });
            document.querySelectorAll('.pack').forEach(pack => {
                pack.style.display = 'block';
            });
        });

