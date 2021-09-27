export const state = () => ({
  menus: [],
  authorizedPaths: [],
  unAuthorizedPaths : ["/","/registration"]
});

export const mutations = {
  setMenusAndPaths(state,userInfo) {
    state.menus = userInfo.menus;
    state.authorizedPaths = userInfo.paths;
  }
};
