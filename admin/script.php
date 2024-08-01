<script>
var hamburger = document.querySelector(".hamburger");
hamburger.addEventListener("click", function() {
    document.querySelector("body").classList.toggle("active");
})

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
</script>