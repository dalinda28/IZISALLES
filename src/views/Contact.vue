<template>
<div class="container">
	<div class="form-row">
      <div class="col-md-6 col-md-offset-3">
        <div class="align-items-center">
          <form class="form-horizontal" action="" method="post">
          <fieldset>
            <legend class="text-center">Contact</legend>
    
            <!-- Name input-->
            <div class="form-group">
              <label for="exampleInputEmail1">Nom</label>
              <input type="name" class="form-control" id="exampleInputName" placeholder="Votre nom">
            </div>
    
            <!-- Email input-->
            <div class="form-group ">
              <label for="exampleInputName">Prénom</label>
              <input type="email" class="form-control" id="exampleInputLastName" placeholder="Votre prénom">
            </div>
            
            <!-- Email input-->
            <div class="form-group ">
              <label for="exampleInputEmail1">Email address</label>
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
                <button type="submit" class="btn btn-secondary btn-lg">Envoyer</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
      </div>
	</div>
</div>

</template>

<script>
export default {

}
</script>

<style>
.container{
  position: absolute;
   left: 50%;
   top: 50%;
   margin-left: -250px;
   margin-top: -185px;
}
</style>