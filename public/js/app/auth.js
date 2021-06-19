class Auth  {
  middlewareGuest() {
    if (this.isLoggedIn()) {
      this.redirect('list');
      return true;
    }
    return true;
  }


  middlewareAuthorized() {
    if (!this.isLoggedIn()) {
      this.redirect('login');
    }
    return true;
  }


  isLoggedIn() {
    const auth = this.get();
    return (!!auth && !!auth.user && !!auth.token);
  }

  /**
   * Check auth data
   */
  check() {
    const auth = this.get();
    //TODO: add fingerptint support
    if (!this.isLoggedIn()) {
      this.redirect('list');
    }
    else {
      this.redirect('login');
    }
  }

  /**
   * Redirect
   * @param {String} page_name
   */
  redirect(page_name) {
    window.location.replace(`/${page_name}.html`);
  }


  /**
   * Set auth data
   */
  set(data) {
    localStorage['auth'] = JSON.stringify(data);
  }


  /**
   * Get auth data
   */
  get() {
    return (!!localStorage['auth']) ? JSON.parse(localStorage['auth']) : null;
  }


  logout() {
    delete localStorage.auth;
    this.redirect('login');
  }
}
