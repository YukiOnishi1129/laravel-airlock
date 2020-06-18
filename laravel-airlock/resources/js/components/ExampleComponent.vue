<template>
  <div class="p-5">
    <h1>Laravel Airlock</h1>
    <button class="btn btn-success mb-3" @click="getUser">ユーザ情報取得</button>
    <button class="btn btn-danger mb-3" v-if="loggedIn" @click="logout">ログアウト</button>
    <form @submit.prevent="login" v-else>
      <div>
        <label>Email:</label>
        <input v-model="email" />
      </div>
      <div>
        <label>Password:</label>
        <input v-model="password" />
      </div>
      <button class="btn btn-primary" type="submit">ログイン</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "test@gmail.com",
      password: "password",
      loggedIn: false
    };
  },
  methods: {
    login() {
      //CSRF protectionを初期化する
      axios.get("/sanctum/csrf-cookie").then(response => {
        //   ログイン認証
        axios
          // web.phpの'/login'のルートで処理している
          // authコマンドの実装で作成したロジック
          .post("/login", {
            email: this.email,
            password: this.password
          })
          .then(response => {
            console.log(response);
            this.loggedIn = true;
          })
          .catch(error => {
            console.log(error.response.data);
            this.loggedIn = false;
          });
      });
    },
    logout() {
      // authコマンドの実装で作成したロジック
      axios.post("/logout").then(response => {
        console.log(response);
        if (response.status === 204) {
          this.loggedIn = false;
        }
      });
    },
    getUser() {
      axios
        .get("/api/user")
        .then(response => {
          console.log(response.data);
        })
        .catch(error => {
          alert(error.response.data.message);
          this.loggedIn = false;
        });
    }
  }
};
</script>
