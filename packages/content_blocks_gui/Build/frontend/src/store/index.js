import { createStore } from 'vuex';

const store = createStore({
    modules: {
    },
    state() {
      return {
        currentContentBlock: 'FirstCB'
      };
    },
    getters: {
        currentContentBlock(state) {
            return state.currentContentBlock;
            },
    }
  });
  
  export default store;