let users = {
    state: {
        users: [
            {id: 1, 'name': '向军老师'},
        ]
    },
    getters: {
        getUsers(state){
            return state.users;
        }
    }
};
export default users;