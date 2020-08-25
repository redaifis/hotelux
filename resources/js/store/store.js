import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        userToken: localStorage.getItem('user-token') || null,
        user: JSON.parse(localStorage.getItem('user')) || {},
        isLoading: false,

    },
    mutations:{
        updateProfile(state, profile){

        }
    },
    getters: {
        isUserLoggedIn(state) {
            return state.userToken ? true : false
        },
        isAdmin(state) {
            return state.user.role === 'admin' && state.userToken ? true : false
        },
    },
    actions: {


        displayRegisterForm() {
            $('#register').modal('toggle')
        },

        async loginUser({state}, userToLogin) {

            state.isLoading = true

            try {

                const result = await axios.post(`/api/auth/login`, userToLogin)

                localStorage.setItem('user-token', result.data.access_token);
                localStorage.setItem('user', JSON.stringify(result.data.user));
                console.log(result.data.user)
                if (result.data.user.role === "customer") window.location.replace('/customer')
                if (result.data.user.role === "admin") window.location.replace('/admin')

            } catch (error) {
                console.log(error)
                alert('invalid credentials!')
            }


            state.isLoading = false
        },


        async registerUser({}, newUser) {

            state.isLoading = true

            console.log(newUser)

            if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(newUser.email))) alert('Invalid email address!')

            if (newUser.password !== newUser.password_confirmation) alert('Passwords don\'t match')

            // if (newUser.phone.match(/\d/g).length !== 10) return alert('Invalid phone number!')

            try {
                const result = await axios.post(`/api/auth/register`, newUser)
                $('#register').modal('hide')
                alert('Success! A new account is registred, try to login!')
                // window.location.replace('/login')
            } catch (error) {
                console.log(error)
                alert('User has not been registred, try again later!')
            }

            state.isLoading = false
        },

        async logout(state) {

            state.isLoading = true

            try {
                const logout = await axios.post(
                    '/api/auth/logout'
                )

                localStorage.removeItem("user-token");
                localStorage.removeItem("user");

                window.location.replace('/');

            } catch (error) {

                console.log(error)

                localStorage.removeItem("user-token");
                localStorage.removeItem("user");

                window.location.replace('/');
            }

            state.isLoading = true
        },
        async isUserLoggedIn(){
            try {
                const result = await axios.get('/api/auth/check')
                if(!result.data.auth){
                    localStorage.removeItem('user-token')
                    localStorage.removeItem('user')
                    window.location.replace('/login')
                }


            } catch (error) {
                console.log(error)
            }
        },
        async getProfile(commit){
            try {
                const result = await axios.get('/api/auth/profile')
                console.log(result)
                localStorage.setItem('user', JSON.stringify(result.data.profile))
            } catch (error) {
                console.log(error)
            }
        }
    }
})
