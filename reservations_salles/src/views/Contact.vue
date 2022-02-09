<template>
<div class="container">
	<div class="form-row row p-5">
      <div class="centered col-md-6 col-md-offset-3">
        <div class="align-items-center">
          <div class="form-horizontal" >
          <fieldset>
            <legend class="text-center">Contact</legend>
    
            <!-- Name input-->
            <div class="form-group">
              <label for="exampleInputEmail1">Nom</label>
              <input type="name" class="form-control" id="exampleInputName" placeholder="Votre nom">
            </div>
    
            <!-- LastName input-->
            <div class="form-group ">
              <label for="exampleInputName">Prénom</label>
              <input type="email" class="form-control" id="exampleInputLastName" placeholder="Votre prénom">
            </div>
            
            <!-- Email input-->
            <div class="form-group ">
              <label for="exampleInputEmail1">Adresse mail</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Votre email">
            </div>
    
            <!-- Message body -->
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Message</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Votre message"></textarea>
            </div>
    
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-secondary btn" @click="showMsg=true">Envoyer</button>
              </div>
            </div>
          </fieldset>
          </div>
        </div>
      </div>
      <div id="overlay" v-if="showMsg">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="modal-title">Votre message a été envoyée avec succès</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" @click="refreshPage()" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>

</template>

<script>
export default {
  data(){
      return {
          showMsg: false,
      }
    },
    methods:{
      //rafraîchissement de la page
      refreshPage() {
          this.showMsg = false;
          this.$router.push('/');
      },
    }
}
</script>

<style scoped>
 #overlay{
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
  }
.container{
    width: 70%;
    margin-top: 10%;
}
.modal-dialog{
    top:40%
}
body{
    padding-top: 5%;
    background: rgb(245,245,245);
}
.row{
    background: white;
    border-radius: 30px;
    box-shadow: 12px 12px 22px grey;
}
.centered{
  margin-left: 25% ;
}
button{
  color: white;
  background-color: black;
}

</style>