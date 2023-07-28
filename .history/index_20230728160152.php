<?php
require_once 'navbar.php';
require_once 'sidebar.php';
?>
<!-- Static home page -->
<div class=" col-11">
  <!--Homepage crausel -->
  <div class="col-12 px-2 mt-3 mb-4">
    <div id="carouselExampleInterval" class="carousel slide col-12 col-lg-8 mx-auto" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="2000">
          <img src="https://images.unsplash.com/photo-1629904853716-f0bc54eea481?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item" data-bs-interval="3000">
          <img src="https://images.pexels.com/photos/7988079/pexels-photo-7988079.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item" data-bs-interval="3000">
          <img src="https://images.pexels.com/photos/4021262/pexels-photo-4021262.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="...">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
  <!-- Homepage Statistics -->
  <div class="container-fluid">
    <section>
      <div class="row mt-3">
        <div class="col-12 mt-3 mb-1">
          <h5 class="text-uppercase display-5 text-center">Statistics</h5>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-6 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                    <i class="bi bi-pencil text-primary fs-1 me-4"></i>
                  </div>
                  <div>
                    <h4>Total Posts</h4>
                    <p class="mb-0">Monthly blog posts</p>
                  </div>
                </div>
                <div class="align-self-center">
                  <h2 class="h1 mb-0">18,000</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                    <i class="bi bi-chat-left-dots text-warning fs-1 me-4"></i>
                  </div>
                  <div>
                    <h4>Total Comments</h4>
                    <p class="mb-0">Monthly blog posts</p>
                  </div>
                </div>
                <div class="align-self-center">
                  <h2 class="h1 mb-0">84,695</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-6 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                    <h2 class="h1 mb-0 me-4">$76,456.00</h2>
                  </div>
                  <div>
                    <h4>Total Sales</h4>
                    <p class="mb-0">Monthly Sales Amount</p>
                  </div>
                </div>
                <div class="align-self-center">
                  <i class="bi bi-heart text-danger fs-1"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between p-md-1">
                <div class="d-flex flex-row">
                  <div class="align-self-center">
                    <h2 class="h1 mb-0 me-4">$36,000.00</h2>
                  </div>
                  <div>
                    <h4>Total Cost</h4>
                    <p class="mb-0">Monthly Cost</p>
                  </div>
                </div>
                <div class="align-self-center">
                  <i class="bi bi-wallet text-success fs-1"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- Home Page Software info Image -->
 <div class="col-12 d-flex justify-content-center">
  <img src="//admin/assets/img/softwareUse.png" class="img-fluid rounded-top" alt="">
 </div>
 <!-- Employee of the month  -->
  <div class="container">
    <div class="col-12 mt-3 mb-1">
      
      <h5 class="text-uppercase display-5 text-center"><img src="//admin/assets/img/badge.png" alt="..." width='50px'>Employee Of The Month<img src="../admin/assets/img/badge.png" alt="..." width='50px'></h5>
    </div>
    <div class="row justify-content-center align-items-center g-2">
      <div class="col">
        <section class="mx-auto my-5" style="max-width: 23rem;">

          <div class="card testimonial-card mt-2 mb-3">
            <div class="card-up aqua-gradient"></div>
            <div class="avatar mx-auto white">
              <img src="//admin/assets/img/avatarimg.png" class="rounded-circle img-fluid" alt="woman avatar">
            </div>
            <div class="card-body text-center">
              <h4 class="card-title font-weight-bold">Govind Jha</h4>
              <hr>
              <p class='fs-5'><i class="bi bi-patch-check text-success"></i>Software Developer Trainee</p>
              <p>PHP OPS</p>
            </div>
          </div>

        </section>
      </div>
      <div class="col">
        <section class="mx-auto my-5" style="max-width: 23rem;">

          <div class="card testimonial-card mt-2 mb-3">
            <div class="card-up aqua-gradient"></div>
            <div class="avatar mx-auto white">
              <img src="//admin/assets/img/pngwing.com (8).png" class="rounded-circle img-fluid" alt="woman avatar">
            </div>
            <div class="card-body text-center">
              <h4 class="card-title font-weight-bold">Jaynesh Mehta</h4>
              <hr>
              <p class='fs-5'><i class="bi bi-patch-check text-success"></i>Software Developer Trainee</p>
              <p>PHP Custom</p>
            </div>
          </div>

        </section>
      </div>
      <div class="col">
        <section class="mx-auto my-5" style="max-width: 23rem;">

          <div class="card testimonial-card mt-2 mb-3">
            <div class="card-up aqua-gradient"></div>
            <div class="avatar mx-auto white">
              <img src="//admin/assets/img/pngwinggirl.com .png" class="rounded-circle img-fluid" alt="woman avatar">
            </div>
            <div class="card-body text-center">
              <h4 class="card-title font-weight-bold">Shrusti Jha</h4>
              <hr>
              <p class='fs-5'><i class="bi bi-patch-check text-success"></i> Software Developer Trainee</p>
              <p>React</p>
            </div>
          </div>

        </section>
      </div>
    </div>
  </div>
</div>
<script src="//admin/assets/js/script.js"></script>
<?php
echo $script;
require_once 'admin/lib/footer.php';
?>