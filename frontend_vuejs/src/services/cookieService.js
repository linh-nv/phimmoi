import Cookies from "js-cookie";

export const cookieService = {
  setToken(tokenData) {
    const { access_token, refresh_token, expires_in, refresh_expires_in } =
      tokenData || {};

    if (!access_token || !refresh_token) {
      console.error("Access token or refresh token is missing.");
      return;
    }

    const accessTokenExpires = new Date(
      new Date().getTime() + expires_in * 60 * 1000,
    );
    const refreshTokenExpires = new Date(
      new Date().getTime() + refresh_expires_in * 60 * 1000,
    );

    Cookies.set("access_token", access_token, { expires: accessTokenExpires });
    Cookies.set("refresh_token", refresh_token, {
      expires: refreshTokenExpires,
    });
    Cookies.set("access_token_expires", accessTokenExpires.getTime());
    Cookies.set("refresh_token_expires", refreshTokenExpires.getTime());
  },

  getAccessToken() {
    return Cookies.get("access_token");
  },

  getRefreshToken() {
    return Cookies.get("refresh_token");
  },

  getAccessTokenExpires() {
    return Cookies.get("access_token_expires");
  },

  getRefreshTokenExpires() {
    return Cookies.get("refresh_token_expires");
  },

  removeTokens() {
    Cookies.remove("access_token");
    Cookies.remove("refresh_token");
    Cookies.remove("access_token_expires");
    Cookies.remove("refresh_token_expires");
  },
};
