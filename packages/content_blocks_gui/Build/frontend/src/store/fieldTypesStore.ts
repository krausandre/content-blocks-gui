import {defineStore} from "pinia";

export const useFieldTypesStore = defineStore('globalProperties',{
  state:() => ({
    currentView: "c-b-list-view"
  }),
  getters: {
    getCurrentView: state => state.currentView,
    getIsCbListView: state => state.currentView === "c-b-list-view",
    getIsEditView: state => state.currentView === "edit-cb-view",
  },
  actions: {
    setCurrentView(newView: string) {
        this.currentView = newView;
    },
    setCurrentViewToCbListView() {
        this.setCurrentView("c-b-list-view");
    },
    setCurrentViewToEditView() {
        this.setCurrentView("edit-cb-view");
    }
  },
});
