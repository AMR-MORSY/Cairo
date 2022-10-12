<template>

 <main class="form-signin w-25 m-auto">
    <form @submit.prevent="submitRegisterForm">
      <img
        class="mb-4"
        src="../assets/brand/bootstrap-logo.svg"
        alt=""
        width="72"
        height="57"
      />
      <h1 class="h3 mb-3 fw-normal">Please Register</h1>
      <div class="form-floating">
        <input
          type="text"
          class="form-control"
          id="floatingUserName"
          placeholder="name@example.com"
          v-model="form.name"
        />
        <label for="floatingUserName">User Name</label>
      </div>

      <div class="form-floating mt-1">
        <input
          type="email"
          class="form-control"
          id="floatingInput"
          placeholder="name@example.com"
          v-model="form.email"
        />
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating mt-1">
        <input
          type="password"
          class="form-control"
          id="Password"
          autocomplete="on"
          placeholder="Password"
          v-model="form.password"
        />
        <label for="Password">Password</label>
      </div>
       <div class="form-floating mt-1">
        <input
          type="password"
          class="form-control"
          id="floatingConfirmPassword"
          placeholder="Password"
          autocomplete="on"
          v-model="form.password_confirmation"
        />
        <label for="floatingConfirmPassword">Confirm Password</label>
      </div>

      
      <button class="w-100 btn btn-lg btn-primary mt-1" type="submit">
        Sign in
      </button>
   
    </form>
  </main>
  
</template>

<script>
import User from "../../../apis/User";
export default {
  
   data(){
    return{
        form:{
            name:"",
            email:"",
            password:'',
           password_confirmation:"",
        }
    }
   },
   methods:{
    submitRegisterForm(){
       User.register(this.form).then(()=>{
        this.$router.push({path:"/user/login"})
       }).catch(error=>{
        if(error.response)
        {


        }
        if(error.request)
        {

        }
       });
    }
   }
}
</script>

<style lang="scss" scoped>
.bd-placeholder-img {
  font-size: 1.125rem;
  text-anchor: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}

@media (min-width: 768px) {
  .bd-placeholder-img-lg {
    font-size: 3.5rem;
  }
}

.b-example-divider {
  height: 3rem;
  background-color: rgba(0, 0, 0, 0.1);
  border: solid rgba(0, 0, 0, 0.15);
  border-width: 1px 0;
  box-shadow: inset 0 0.5em 1.5em rgba(0, 0, 0, 0.1),
    inset 0 0.125em 0.5em rgba(0, 0, 0, 0.15);
}

.b-example-vr {
  flex-shrink: 0;
  width: 1.5rem;
  height: 100vh;
}

.bi {
  vertical-align: -0.125em;
  fill: currentColor;
}

.nav-scroller {
  position: relative;
  z-index: 2;
  height: 2.75rem;
  overflow-y: hidden;
}

.nav-scroller .nav {
  display: flex;
  flex-wrap: nowrap;
  padding-bottom: 1rem;
  margin-top: -1px;
  overflow-x: auto;
  text-align: center;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
}

</style>