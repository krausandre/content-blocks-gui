import {defineStore} from "pinia";

export const useGlobalPropertiesStore = defineStore('globalProperties', {
    state: () => ({
        currentView: "c-b-list-view",
        isLoading: false
    }),
    getters: {
        getCurrentView: state => state.currentView,
        getIsCbListView: state => state.currentView === "c-b-list-view",
        getIsEditView: state => state.currentView === "edit-cb-view",
        getIsLoading: state => state.isLoading,
    },
    actions: {
        setIsLoading(newIsLoading: boolean) {
            this.isLoading = newIsLoading;
        },
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
