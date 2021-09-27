export default function ({ app, store, redirect, error, route}) {

  let userInfo = app.$cookies.get('userInfo');

  if(userInfo){
    if(store.state.unAuthorizedPaths.includes(route.path)){
      redirect("/dashboard/home")
    }

    if(!store.state.authorizedPaths.includes(route.path)){
      redirect("/dashboard/home")
    }
  }else {
    if(route.path.indexOf("dashboard")  > -1){
      redirect("/")
    }
  }

}

