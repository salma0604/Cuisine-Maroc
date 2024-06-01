{{-- <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Image Carousel</title>
<style>
    /* Styles for the image gallery */
    .image-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .image-item {
        flex: 1 1 200px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    .image-item:hover {
        transform: scale(1.1);
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 999;
        justify-content: center;
        align-items: center;
    }
    .modal-content {
        max-width: 80%;
        max-height: 80%;
    }
    .btn-container {
        margin-top: 10px;
    }
    .btn {
        padding: 5px 10px;
        margin: 0 5px;
        cursor: pointer;
    }
</style>
</head>
<body>
    <div class="image-gallery">
        <div class="image-item">
            <img src="/images/macarons.jpg" alt="Image 1" onclick="openModal('/images/macarons.jpg')">
        </div>
        <!-- Add more image items here -->
    </div>

    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImg" src="">
        <div class="btn-container">
            <button class="btn" onclick="prevImage()">Précédent</button>
            <button class="btn" onclick="nextImage()">Suivant</button>
        </div>
    </div>

    <script>
        let currentImageIndex = 0;
        const images = [
            "/images/macarons.jpg",
            "/images/Harira.jpeg",
            "/images/Couscous_royal.jpg",
            "/images/poisson.jpeg"
            // Add more image URLs as needed
        ];

        function openModal(imageUrl) {
            const modal = document.getElementById("myModal");
            const modalImg = document.getElementById("modalImg");
            modal.style.display = "flex";
            modalImg.src = imageUrl;
            currentImageIndex = images.indexOf(imageUrl);
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            const modalImg = document.getElementById("modalImg");
            modalImg.src = images[currentImageIndex];
        }

        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            const modalImg = document.getElementById("modalImg");
            modalImg.src = images[currentImageIndex];
        }

        // Close the modal when clicking outside the image
        window.onclick = function(event) {
            const modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>
</body>
</html> --}}
