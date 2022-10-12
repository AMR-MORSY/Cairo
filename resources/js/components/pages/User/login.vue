<template>
  <main class="form-signin w-25 m-auto">
    <form @submit.prevent="submitLoginForm">
      <img
        class="mb-4"
        src="../assets/brand/bootstrap-logo.svg"
        alt=""
        width="72"
        height="57"
      />
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <div v-if="isError">
        <p style="color:red">{{error}}</p>
      </div>

      <div class="form-floating">
        <input
          type="email"
          v-model="form.email"
          class="form-control"
          id="floatingInput"
          placeholder="name@example.com"
        />
        <label for="floatingInput">Email address</label>
      </div>
      <div v-if="isEmailError">
        <p v-for="error in emailError" :key="error" style="color:red">{{error}}</p>
      </div>
      <div class="form-floating mt-1">
        <input
          type="password"
          class="form-control"
          id="password"
          autocomplete="on"
          placeholder="Password"
          v-model="form.password"
        />
        <label for="password">Password</label>
      </div>
      <div v-if="isPasswordError">
        <p v-for="error in passwordError" :key="error" style="color:red">{{error}}</p>
      </div>

      <div class="checkbox mb-3">
      <router-link to="/user/resetPassword" >Forgot Password?</router-link>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">
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
            email:"",
            password:"",
            },
            error:"",
            isError:false,
            passwordError:[],
            isPasswordError:false,
            emailError:[],
            isEmailError:false,

           
        }
    },
  name: "login",
  methods:{
    submitLoginForm()
    {
     
        User.login(this.form).then(data=>{
          localStorage.setItem("Auth",true);
        this.$router.push({
          path:"/home"
        });
        }).catch((error)=>{
          if(error.response){
              console.log(error.response);
            if(error.response.status==401)
            {
              this.error=error.response.data.message;
              this.isError=true;
        

            }
            else if(error.response.status==422)
            {
              let err=error.response.data.errors;
              if(err.email)
              {
                this.emailError=err.email;
                this.isEmailError=true;

              }
              if(err.password)
              {
                this.passwordError=err.password;
                this.isPasswordError=true;


              }
              
        

            }

          }
          
        })
    }

  }
};
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