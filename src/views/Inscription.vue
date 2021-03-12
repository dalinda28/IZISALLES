<template>
    <div>
        <section class="form my-5 mx-5">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-lg-5">
                        <img src="../assets/room2.jpg" class="img-fluid" alt="room">
                    </div>

                    <div class="col-lg-7 px-5 pt-5">
                        <h1 class="font-weight-bold py-3">Logo</h1>
                        <h4></h4>
                        <form>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <input type="Nom" placeholder="Nom d'utilisateur" class="form-control my-3 p-4">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <input type="email" placeholder="test@test.com" class="form-control my-3 p-4">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <input type="password" placeholder="*********" class="form-control my-3 p-4">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <button type="button" class="btn1 mt-3 mb-5">S'inscrire</button>
                                </div>
                            </div>
                            
                            <router-link :to="{name:'connexion'}" class="nav-link" href="/connexion"><p>Se connecter</p></router-link>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {

}
</script>

<style>
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    padding-top: 5%;
    background: rgb(245,245,245);
}
.container{
    width: 70%;
}
.row{
    background: white;
    border-radius: 30px;
    box-shadow: 12px 12px 22px grey;
}
img{
    border-top-left-radius: 30px;
    border-bottom-left-radius: 30px;
}
.img-fluid{
    background-color: black;

}
.btn1{
    border: none;
    outline:  none;
    height: 50px;
    width: 100%;
    background-color: black;
    color: white;
    border-radius: 4px;
    font-weight: bold;
}
.btn1:hover{
    background-color: white;
    border: 1px solid;
    color: black; 
}
</style>