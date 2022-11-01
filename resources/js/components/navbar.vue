<template>
  <nav class="navbar mb-5 navbar-expand-lg">
    <a class="navbar-brand font-weight-bolder">CairoSouth</a>
    <div class="form-group">
      <form class="form-inline ml-5">
        <input
          class="mr-sm-2 search form-control"
          type="text"
          aria-label="Search"
        />
        <button type="submit" class="form-control searchBtn">Search</button>
      </form>
    </div>

    <a
      class="ofcan-btn"
      data-bs-toggle="offcanvas"
      data-bs-target="#offcanvasExample"
      aria-controls="offcanvasExample"
    >
      <div class="menue-btn">
        <div class="menue-btn-burger"></div>
      </div>
    </a>
    <div
      class="collapse flex-grow-0 navbar-collapse"
      id="navbarSupportedContent"
    >
      <ul class="navbar-nav">
        <li class="nav-item active">
          <!-- <a class="nav-link"  Active >Home </a> -->
          <router-link class="nav-link" to="/home" Active>Home</router-link>
        </li>
        <li class="nav-link" v-if="userName">
          {{ userName.name }}
        </li>

        <!-- <li class="nav-item">
          <div class="image_container">
            <img class="w-100 h-100" />
          </div>
        </li> -->

        <li class="nav-item">
          <p class="nav-link"></p>
        </li>
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            id="dropdownMenuLink"
            aria-haspopup="true"
            aria-expanded="false"
            v-if="isLogin"
          >
            Admin
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li class="nav-item">
              <div class="test">
                <a class="dropdown-item">Sites</a>
                <div class="test2">
                  <!-- <a class="dropdown-item ">All Sites</a> -->

                  <!-- <a class="dropdown-item " >Create New</a> -->
                  <router-link class="dropdown-item" to="/sites/store"
                    >Create New</router-link
                  >
                    <router-link class="dropdown-item" to="/sites/cascades"
                    >Cascades</router-link
                  >
                    <router-link class="dropdown-item" to="/sites/nodals"
                    >Nodals</router-link
                  >
                </div>
              </div>
            </li>
            <!-- <li><a class="dropdown-item">Modifications</a></li> -->
               <router-link class="dropdown-item" to="/modifications">Modifications</router-link>
            <li class="nav-item">
              <div class="test">
                <router-link class="dropdown-item" to="/nur">NUR</router-link>
                <div class="test2">
                  <!-- <a class="dropdown-item">Show NUR</a> -->
                  <router-link class="dropdown-item" to="/nur/2G"
                    >2G</router-link
                  >
                  <router-link class="dropdown-item" to="/nur/3G"
                    >3G</router-link
                  >
                  <router-link class="dropdown-item" to="/nur/4G"
                    >4G</router-link
                  >
                </div>
              </div>
            </li>
            <li class="nav-item">
              <div class="test">
                <a class="dropdown-item">Energy Sheet</a>
                <div class="test2">
                  <!-- <a class="dropdown-item " >Insert Sheet</a> -->
                  <router-link to="/energysheet/index" class="dropdown-item"
                    >Insert Sheet</router-link
                  >
                </div>
              </div>
            </li>
            <li><a class="dropdown-item">Users</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" v-if="isLogin">Profile</a>
        </li>
        <li class="nav-item">
          <router-link v-if="!isLogin" class="nav-link" to="/user/login"
            >Login</router-link
          >
          <!-- <a class="nav-link" >Login</a> -->
        </li>
        <li class="nav-item">
          <a class="nav-link" v-if="isLogin" @click="logout">Logout</a>
        </li>
        <li class="nav-item">
          <router-link v-if="!isLogin" class="nav-link" to="/user/register"
            >Register</router-link
          >
          <!-- <a class="nav-link" >Register</a> -->
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import User from "../apis/User";

export default {
  data() {
    return {
      // isLogin:this.$store.state.isLogin,
    };
  },
  name: "navbar",
  computed: {
    isLogin() {
      return this.$store.state.isLogin;
    },
    userName() {
      return this.$store.state.user;
    },
  },
  mounted() {
    // this.checkingLogin();
  },
  methods: {
    logout() {
      User.logout()
        .then((data) => {
          console.log(data);

          sessionStorage.removeItem("Auth");
          sessionStorage.removeItem("userData");
          this.$store.dispatch("changeLoginState", false);
          this.$store.dispatch("userData", null);
          this.$store.dispatch("userPermissions", null);
          this.$store.dispatch("userRoles", null);
          // this.isLogin=false;
          this.$router.push({ path: "/user/login" });
        })
        .catch((error) => {
          //   console.log(error);
          //   if (error.response.status == 401 || error.response.status == 403) {
          //     this.$router.push({ path: "/user/login" });
          //   }
        });
    },

    // checkingLogin() {
    //   this.isLogin = this.$store.getters.checkingLogin;
    // },
  },
};
</script>

<style lang="scss"  scoped>
.navbar {
  position: fixed;
  display: flex;
  background-color: #79589f;
  justify-content: space-around;
  z-index: 100;
  width: 100%;
  top: 0;
  left: 0;
  .nav-link,
  .navbar-brand {
    color: white;
    cursor: pointer;
  }
  .navbar-brand {
    font-size: 1.5rem;
    font-weight: 800;
  }
  .ofcan-btn {
    display: none;
  }

  .menue-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.5s ease-in-out;
  }
  .menue-btn-burger {
    position: relative;
    width: 25px;
    height: 4px;
    background-color: white;
    border-radius: 3px;
    transition: all 0.5s ease-in-out;
  }
  .menue-btn-burger::before,
  .menue-btn-burger::after {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    width: 25px;
    height: 4px;
    background-color: white;
    border-radius: 3px;
    transition: all 0.5s ease-in-out;
  }
  .menue-btn-burger::before {
    transform: translateY(-10px);
  }
  .menue-btn-burger::after {
    transform: translateY(10px);
  }
  .menue-btn.open .menue-btn-burger {
    transform: translateX(-30px);
    background-color: transparent;
  }
  .menue-btn.open .menue-btn-burger::before {
    transform: rotate(45deg) translate(21px, -21px);
  }
  .menue-btn.open .menue-btn-burger::after {
    transform: rotate(-45deg) translate(21px, 21px);
  }

  .form-group {
    background-color: transparent;
    width: 40%;
    position: relative;
    // display: flex;
    // justify-content: space-between;
    // align-items: center;
    .search {
      width: 100%;
      // height: 30px;
    }
    .searchBtn {
      position: absolute;
      width: 15%;
      margin: 0 !important;
      top: 0;
      right: 0;
      // height: 28px;
      text-align: center;
      background-color: green;
      // border: 3px solid transparent;
    }
  }

  .collapse {
    display: flex;
    justify-content: center;
    .image_container {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: burlywood;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1rem;
      i {
        display: block;
      }
      img {
        display: block;
      }
    }
    .dropdown-item {
      cursor: pointer;
    }
    .dropdown:hover .dropdown-menu {
      display: block;
    }
    .test {
      position: relative;
      height: 30px;
      width: 100%;
      .test2 {
        background-color: #aaaaaa;
        position: absolute;
        top: 20%;
        right: 100%;
        display: none;
        border-radius: 3px;
        z-index: 1;
      }
    }
    .test:hover .test2 {
      display: block;
    }
  }
}

.offcanvas {
  width: 20% !important;
  height: unset !important;
  .offcanvas-body {
    font-size: 1rem;
    background: #040b14;
    p {
      font-family: "Poppins", sans-serif;
      font-size: 1.1rem;
      font-weight: 300;
      line-height: 1.7em;
      color: #999;
    }
    .side-bar {
      padding-top: 2em;
      color: #fff;
      width: 100%;
      // height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      .image_container {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: burlywood;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        i {
          display: block;
        }
        img {
          display: block;
        }
      }
      .components {
        border-bottom: 1px solid #47748b;
      }
      .components,
      .component {
        padding: 20px 0;
        width: 100%;
        p {
          color: #fff;
          padding: 10px;
          text-align: center;
        }
        .nav-link {
          color: white;
        }
        .nav-item {
          text-align: center;
        }

        .dropdown-item {
          cursor: pointer;
          text-decoration: none;
          text-align: center;
          padding: 10px;
          font-size: 1.1em;
          display: block;
          color: black;
        }
        .dropdown-item:hover {
          color: #7386d5;
          background: #fff;
        }
        .dropdown {
          position: relative;
        }
        .dropdown-menu {
          position: absolute;
          top: 80%;
          left: 20%;
        }
        .dropdown:hover .dropdown-menu {
          display: block;
        }
        .test {
          position: relative;
          height: 30px;
          width: 100%;
          .test2 {
            background-color: #aaaaaa;
            position: absolute;
            top: 100%;
            left: 20%;
            z-index: 1;

            display: none;
            border-radius: 3px;
          }
        }
        .test:hover .test2 {
          display: block;
        }

        .test2:hover {
          display: block;
        }
      }
    }
  }
}

@media screen and (max-width: 575px) {
  .navbar {
    .navbar-brand {
      font-size: 1rem;
    }
    .ofcan-btn {
      display: inline-block;
    }
    .collapse {
      display: none;
    }
    .form-group {
      width: 45%;
      .searchBtn {
        width: 45%;

        font-size: 1rem;
        padding-left: 0;
        padding-right: 0;
      }
    }
  }
  .offcanvas {
    width: 55% !important;
    .offcanvas-body {
      p {
        font-size: 1rem;
      }
    }
  }
}

@media (min-width: 576px) and (max-width: 767px) {
  .navbar {
    .ofcan-btn {
      display: inline-block;
    }
    .collapse {
      display: none;
    }
    .form-group {
      width: 60%;
      .searchBtn {
        width: 30%;
      }
    }
  }
}

@media (min-width: 768px) and (max-width: 991px) {
  .navbar {
    .ofcan-btn {
      display: inline-block;
    }
    .collapse {
      display: none;
    }
    .form-group {
      width: 70%;
      .searchBtn {
        width: 30%;
      }
    }
  }
}

@media (min-width: 992px) and (max-width: 1199px) {
  .navbar {
    .collapse {
      justify-content: flex-end;
      width: 80%;
      .form-group {
        width: 50%;
      }
    }
  }
}

@media (min-width: 1200px) and (max-width: 1500px) /* extra large windows*/ {
}
</style>