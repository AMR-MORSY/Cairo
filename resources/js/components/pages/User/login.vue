<template>
  <main class="form-signin w-25 m-auto">
    <form @submit.prevent="submitLoginForm">
      <img class="mb-4" alt="" width="72" height="57" />
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <div v-if="credentialsError">
        {{ credentialsError }}
      </div>

      <div class="form-floating">
        <input
          type="email"
          v-model="form.email"
          class="form-control"
          id="floatingInput"
          placeholder="name@example.com"
          :class="{ 'is-invalid': isEmailInvalid, 'is-valid': form.email }"
        />
        <label for="floatingInput">Email address</label>
      </div>
      <div v-if="emailError">
        <p  style="color: red">
          {{ emailError }}
        </p>
      </div>
      <div class="form-floating mt-1">
        <input
          type="password"
          class="form-control"
          id="password"
          autocomplete="on"
          placeholder="Password"
          v-model="form.password"
          :class="{ 'is-invalid': isPassInvalid, 'is-valid': form.password }"
        />
        <label for="password">Password</label>
      </div>
      <div v-if="passwordError">
        <p style="color: red">
          {{passwordError}}
        </p>
      </div>

      <div class="checkbox mb-3">
        <router-link to="/user/resetPassword">Forgot Password?</router-link>
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
  data() {
    return {
      form: {
        email: null,
        password: null,
      },

      passwordError: null,
      credentialsError: null,

      emailError: null,
    };
  },
  name: "login",
  computed: {
    isPassInvalid()
    {
      if(this.passwordError||this.credentialsError)
      {
        return true
      }
      else{
        return false;
      }
    },
    isEmailInvalid()
    {
      if(this.emailError||this.credentialsError)
      {
        return true
      }
      else{
        return false;
      }
    },
    isLogin() {
      return this.$store.state.isLogin;
    },
  },
 
  beforeRouteEnter(to, from, next) {
    next((vm) => {
      if (vm.isLogin) {
     
      return vm.$router.push(from.path) ;
      } 
    });
  },
  methods: {
    submitLoginForm() {
      this.passwordError = null;
      this.emailError = null;
      this.credentialsError = null;
      // this.isPassInvalid=false;
      // this.isEmailInvalid=false;
      if (!this.form.email) {
        this.emailError = "Email is required";
      }
      if (!this.form.password) {
        this.passwordError = "Password is required";
      }
      if (!this.passwordError && !this.emailError) {
        User.login(this.form)
          .then((response) => {
            console.log(response);
            sessionStorage.setItem("Auth", true);
            sessionStorage.setItem("userData", JSON.stringify(response.data));
            this.$router.push({
              path: "/home",
            });

            this.$store.dispatch("changeLoginState", true);
            this.$store.dispatch("userData",response.data.user);
            this.$store.dispatch('userPermissions',response.data.permissions)
            this.$store.dispatch('userRoles',response.data.roles)
          })
          .catch((error) => {
            if (error.response) {
              console.log(error.response);
              if (error.response.status == 401) {
                this.credentialsError = error.response.data.message;
              }

              if (error.response.status == 422) {
                let err = error.response.data.errors;
                if (err.email) {
                  this.emailError = err.email;
                }
                if (err.password) {
                  this.passwordError = err.password;
                }
              }
            }
          });
      }
    },
  },
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