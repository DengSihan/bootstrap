export const state = () => ({
    prevRouter: null
});

export const mutations = {
    setPrevRouter(state, router){
        state.prevRouter = router;
    }
}
