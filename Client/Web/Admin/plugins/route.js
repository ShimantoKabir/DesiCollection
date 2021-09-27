export default ({ app, store, redirect, error, route }) => {

  // app.router.beforeEach((to, from, next) => {
  //   let userInfo = app.$cookies.get('userInfo');
  //   if(userInfo){
  //       if(store.state.unAuthorizedPaths.includes(route.path)){
  //         next({
  //           path : "/dashboard/home"
  //         });
  //       }else {
  //         if(store.state.authorizedPaths.includes(route.path)){
  //           next();
  //         }else {
  //           next({
  //             path : "/dashboard/home"
  //           });
  //         }
  //       }
  //   }else {
  //     if(route.path.indexOf("dashboard")  > -1){
  //       next({
  //         path : "/"
  //       });
  //     }else {
  //       next();
  //     }
  //   }
  // });
}
