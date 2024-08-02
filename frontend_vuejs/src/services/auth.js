import Cookies from "js-cookie";

const TOKEN_KEY = "auth_token";
const TOKEN_EXPIRY_KEY = "token_expiry";

export function getToken() {
  return Cookies.get(TOKEN_KEY);
}

export function setToken(token, expiresIn) {
  Cookies.set(TOKEN_KEY, token, { expires: expiresIn / 86400 });
  const expiryTime = new Date().getTime() + expiresIn * 1000;
  Cookies.set(TOKEN_EXPIRY_KEY, expiryTime);
}

export function removeToken() {
  Cookies.remove(TOKEN_KEY);
  Cookies.remove(TOKEN_EXPIRY_KEY);
}

export function isTokenExpired() {
  const expiryTime = Cookies.get(TOKEN_EXPIRY_KEY);
  if (!expiryTime) {
    return true;
  }
  return new Date().getTime() > expiryTime;
}
