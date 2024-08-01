<script>

var hamburger = document.querySelector(".hamburger");
hamburger.addEventListener("click", function() {
    document.querySelector("body").classList.toggle("active");
})

// Sidebar
function myFunction(x) {
    if (x.matches) {
        document.querySelector("body").classList.add("active");
    } else {
        document.querySelector("body").classList.remove("active");
    }
}

var x = window.matchMedia("(max-width: 700px)")
myFunction(x)
x.addListener(myFunction)

// Image
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function() {
        const previewImage = document.getElementById('previewImage');
        previewImage.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    }
});
</script>
