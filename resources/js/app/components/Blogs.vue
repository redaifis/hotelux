<template>
  <div class="container py-5">
        <div class="row">
            <div class="col-12 mb-3 d-flex align-items-center">
                <h1>Blog Articles</h1>
                <div class="ml-4">
                    <a class="btn btn-warning text-white btn-sm rounded-0" href="#">
                    More
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <a class="img-card" href="#">
                        <img src="/images/slide1.jpg" class="w-100"/>
                    </a>
                    <div class="card-content">
                        <h4 class="card-title">
                            <a href="#"> Lorem, ipsum dolor.
                            </a>
                        </h4>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero nihil odio recusandae reprehenderit optio, dolor dolorum ullam fugit! Consequatur?
                        </p>
                    </div>
                    <div class="card-read-more">
                        <a href="#" class="btn btn-link btn-block text-warning">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
/* Cards */
.card {
  display: block;
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border-radius: 2px;
    transition: .25s all;
}

.card:hover {
box-shadow: 0 3px 9px 0 rgba(0, 0, 0, 0.2), 0 4px 8px 0 rgba(0, 0, 0, 0.15);}

.img-card {
  width: 100%;
  height:200px;
  border-top-left-radius:2px;
  border-top-right-radius:2px;
  display:block;
    overflow: hidden;
}

.img-card img{
  width: 100%;
  height: 200px;
  object-fit:cover;
  transition: all .25s ease;
}

.card-content {
  padding:15px;
  text-align:left;
}

.card-title {
  margin-top:0px;
  font-weight: 700;
  font-size: 1.65em;
}

.card-title a {
  color: #000;
  text-decoration: none !important;
}

.card-read-more {
  border-top: 1px solid #D4D4D4;
}

.card-read-more a {
  text-decoration: none !important;
  padding:10px;
  font-weight:600;
  text-transform: uppercase
}

</style>
