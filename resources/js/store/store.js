import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        currentUser: null
    },
    mutations: {

        async getUserProfile(state) {
            try {
                const profile = await axios.get(
                    '/api/auth/profile'
                )

                state.currentUser = profile.data

            } catch (error) {
                state.currentUser = null
                localStorage.removeItem('user-token')
            }

            if (!state.currentUser) window.location.replace('/');
        },

        async logout(state) {


            try {
                const logout = await axios.post(
                    '/api/auth/logout'
                )

                localStorage.removeItem("user-token");
                state.currentUser = null
                window.location.replace('/');

            } catch (error) {
                console.log(error)
                window.location.replace('/');
            }
        }
    }
})

export default store
