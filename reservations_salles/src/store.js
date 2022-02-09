import { createStore } from 'vuex';

export const store = createStore({
    state: {
        id_user: "",
        firstName: "",
        lastName: "",
        profile: "",
        mail: ""
    },
    mutations: {
        setId(state, id) {
          state.id_user = id;
        },
        setFirstName(state, firstName) {
          state.firstName = firstName;
        },
        setLastName(state, lastName) {
          state.lastName = lastName;
        },
        setProfile(state, profile) {
          state.profile = profile;
        },
        setMail(state, mail) {
          state.mail = mail;
        }
    }
});
