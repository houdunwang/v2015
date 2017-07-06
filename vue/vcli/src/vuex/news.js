let news = {
    state: {
        news: [
            {id: 1, 'title': 'hdphp'},
            {id: 2, 'title': 'hdcms'},
            {id: 3, 'title': '后盾人'},
        ]
    },
    getters: {
        getAllNews(state){
            return state.news;
        }
    }
};
export default news;