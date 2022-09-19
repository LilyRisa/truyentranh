<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/main.css?ver=1.9909">
  <script src="js/app.js"></script>
</head>

<body>
  @include('web._header')
  <div class="main">
    @yield('main')
  </div>
  <img src="img/to-top.png" class="img-back-to-top d-sm-none d-md-none d-lg-block d-none" width="200rem" class="img-fluid" alt="">
  
    <button
        type="button"
        class="btn btn-dark bg_secondary ve-center btn-floating btn-lg rounded-circle justify-content-center"
        id="btn-back-to-top"
        >
  <i class="icon-arrow-up2 fs-25 d-inline"></i>
</button>

  

<script>
  //Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
  ) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>

  @include('web._footer')
</body>
