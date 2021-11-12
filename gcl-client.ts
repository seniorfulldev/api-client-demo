class GunCriticClient {
  client_id: string;
  redirect_uri: string;
  state: string;
  code_challenge: string;
  code: string;
  constructor(option: any = {}) {
    this.client_id = option.client_id;
    this.redirect_uri = option.redirect_uri;

    this.state = option.state;
    this.code_challenge = option.code_challenge;
    this.intializeUI();
    this.grabAuthentication()
    this.test()
  }

  grabAuthentication() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);


    if (urlParams.has("code")) {
      const code = urlParams.get("code")
      this.code = code;
    })
  }

  test() {
    if (this.code) {
      // POST request using fetch() 
      fetch("https://mark.guncritic.com/api/products", {

        // Adding method type 
        method: "GET",

        // Adding headers to the request 
        headers: {
          "Authorization": "Bearer " + this.code,
          "Content-type": "application/json; charset=UTF-8"
        }
      })

        // Converting to JSON 
        .then(response => response.json())

        // Displaying results to console 
        .then(json => console.log(json));
    }
  }

  intializeUI() {
    this.renderLoginButtons();
  }
  getAuthorizationRequestLink() {
    let params = {
      client_id: this.client_id,
      redirect_uri: this.redirect_uri,
      response_type: "code",
      scope: "",
      state: this.state,
      code_challenge: this.code_challenge,
      code_challenge_method: "S256"
    };
    const query_string = Object.keys(params)
      .map(key => `${key}=${params[key]}`)
      .join('&');
    var link = `https:/mark.guncritic.com/oauth/authorize?${query_string}`;
    return link;
  }
  renderLoginButtons() {
    let authorization_link = this.getAuthorizationRequestLink();
    var el = <HTMLElement[]<any>document.getElementsByClassName('gcc-req-login');
    for (var i = 0; i < el.length; i++) {
      el.item(i).href = authorization_link
      console.log(el.item(i));
    }
  }
}