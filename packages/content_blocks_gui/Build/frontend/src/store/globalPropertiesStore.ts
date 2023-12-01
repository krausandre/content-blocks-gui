import {defineStore} from "pinia";
import {AppMainView} from "@/Controller";

export const useGlobalPropertiesStore = defineStore(
  'globalProperties',
  {
    state: () => (
      {
        currentView: AppMainView.LIST_VIEW,
        isLoading: false,
        currentSelectedFieldIdentifier: "",
      }
    ),
    getters: {
      getCurrentView: state => state.currentView,
      getIsCbListView: state => state.currentView === AppMainView.LIST_VIEW,
      getIsEditView: state => state.currentView === AppMainView.EDIT_VIEW,
      getIsLoading: state => state.isLoading,
      getCurrentSelectedFieldIdentifier: state => state.currentSelectedFieldIdentifier,
    },
    actions: {
      setIsLoading(newIsLoading: boolean) {
        this.isLoading = newIsLoading;
      },
      setCurrentView(newView: AppMainView) {
        this.currentView = newView;
      },
      setCurrentViewToCbListView() {
        this.setCurrentView(AppMainView.LIST_VIEW)
      },
      setCurrentViewToEditView() {
        this.setCurrentView(AppMainView.EDIT_VIEW);
      },
      setCurrentSelectedFieldIdentifier(newIdentifier: string) {
        this.currentSelectedFieldIdentifier = newIdentifier;
      },
    },
  }
);
