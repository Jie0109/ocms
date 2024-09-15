<!DOCTYPE html>
<html>
<head>
    <title>Image Overlay with Drag, Resize, and Rotate</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }

        .overlay-image {
            position: absolute;
            top: 20px;
            left: 20px;
            pointer-events: auto;
            resize: both;
            overflow: auto;
            transform-origin: 50% 50%;
        }
    </style>
</head>
<body>

<div class="image-container" ondrop="drop(event)" ondragover="allowDrop(event)">
    <div id="content">
        <img id="backgroundImage" src="images/product/custom.jpg" alt="Background Image">
        <div id="overlayImagesContainer"></div>
        <br>
        <label for="overlayImageUpload">Upload Overlay Images:</label>
        <input type="file" id="overlayImageUpload" accept="image/*" multiple onchange="displayOverlayImages(event)">
        <br>
    </div>
    <label for="resize">Resize:</label>
    <input type="range" id="resize" min="20" max="300" value="100" oninput="resizeImage()">
    <br>
    <label for="rotate">Rotate:</label>
    <input type="range" id="rotate" min="0" max="360" value="0" oninput="rotateImage()">
    <br>
    <button onclick="saveImage()">Upload Image</button>
</div>

<script>
    function allowDrop(event) {
        event.preventDefault();
    }

    function drag(event) {
        event.dataTransfer.setData("text", event.target.id);
    }

    function drop(event) {
        event.preventDefault();
        const overlay = document.getElementById("overlayImage");
        overlay.style.left = event.clientX - overlay.clientWidth / 2 + 'px';
        overlay.style.top = event.clientY - overlay.clientHeight / 2 + 'px';
    }

    function resizeImage() {
        const resizeValue = document.getElementById("resize").value;
        const overlay = document.getElementById("overlayImage");
        overlay.style.width = resizeValue + 'px';
        overlay.style.height = resizeValue + 'px';
    }

    function rotateImage() {
        const rotateValue = document.getElementById("rotate").value;
        const overlay = document.getElementById("overlayImage");
        overlay.style.transform = "rotate(" + rotateValue + "deg)";
    }

    function displayOverlayImages(event) {
        const files = event.target.files;
        const overlayContainer = document.getElementById("overlayImagesContainer");
        overlayContainer.innerHTML = ""; // Clear previous images

        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const overlayImage = document.createElement("img");
                overlayImage.src = e.target.result;
                overlayImage.alt = "Overlay Image";
                overlayImage.classList.add("overlay-image");
                overlayImage.draggable = true;
                overlayImage.ondragstart = drag;
                overlayContainer.appendChild(overlayImage);
            };

            reader.readAsDataURL(files[i]);
        }
    }

    function saveImage() {
        const backgroundImage = document.getElementById("backgroundImage");
        const overlayImages = document.getElementsByClassName("overlay-image");
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");
        canvas.width = backgroundImage.width;
        canvas.height = backgroundImage.height;

        context.drawImage(backgroundImage, 0, 0);

        for (let i = 0; i < overlayImages.length; i++) {
            const overlay = overlayImages[i];
            context.save();
            context.translate(parseInt(overlay.style.left), parseInt(overlay.style.top));
            context.rotate(parseInt(overlay.style.transform.split("(")[1]) || 0);
            context.drawImage(overlay, 0, 0, overlay.width, overlay.height);
            context.restore();
        }

        const combinedImage = canvas.toDataURL("image/jpeg");

        // Send the combinedImage data to the server using an XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log("Image uploaded successfully!");
                } else {
                    console.error("Error uploading image: " + xhr.status);
                }
            }
        };
        xhr.open("POST", "", true);  // Empty URL means the current page itself
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("imageData=" + encodeURIComponent(combinedImage));
    }

    function captureScreenshot() {
        var element = document.getElementById('content');

        html2canvas(element).then(function(canvas) {
            var imgData = canvas.toDataURL('image/png');
            var link = document.createElement('a');
            link.href = imgData;
            link.download = 'screenshot.png';
            link.click();
        });
    }
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["imageData"])) {
    // Decode the base64-encoded image data
    $imageDataArray = explode(',', $_POST["imageData"]);

    foreach ($imageDataArray as $imageData) {
        $imageDataDecoded = base64_decode($imageData);

        // Generate a unique filename for the image
        $filename = uniqid() . '.jpg';

        // Set the file path where you want to store the image
        $filePath = 'images/product/' . $filename;

        // Save the image to the specified file path
        file_put_contents($filePath, $imageDataDecoded);

        $sql = "INSERT INTO custom (custom_img, user_id) VALUES ('$filePath', $uid)";

        if (mysqli_query($link, $sql)) {
            echo "Image uploaded successfully with filename: $filename<br>";
        } else {
            echo "Error uploading image with filename: $filename<br>";
        }
    }
}
?>

<button onclick="captureScreenshot()">Capture Screenshot</button>

</body>
</html>
