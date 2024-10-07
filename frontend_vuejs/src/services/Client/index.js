import { apiClientService } from "./apiClientService";
import {
  CATEGORY_MOVIE_ENDPONIT,
  CHECK_FAVORITE_ENDPONIT,
  CLIENT_API_BASE_URL,
  CLIENT_MOVIE_ENDPONIT,
  COUNTRY_MOVIE_ENDPONIT,
  CREATE_VIEW_ENDPONIT,
  FILTER_ENDPOINT,
  FILTER_OPTION_ENDPOINT,
  GENRE_MOVIE_ENDPONIT,
  HEADER_ENDPONIT,
  MOVIE_COMMENT_ENDPONIT,
  MOVIE_FAVORITE_ENDPONIT,
  MOVIE_TOP_ENDPONIT,
  SEARCH_ENDPONIT,
  SILDER_ENDPONIT,
} from "@/utils/apisDomain";

const endpoint = CLIENT_API_BASE_URL;
const headerEndponit = HEADER_ENDPONIT;
const searchEndponit = SEARCH_ENDPONIT;

export const clientService = {
  getHeader() {
    return apiClientService.get(endpoint + headerEndponit);
  },
  search(keyword) {
    return apiClientService.search(endpoint + searchEndponit, keyword);
  },
  getHome() {
    return apiClientService.get(endpoint);
  },
  getMovieFilter(params) {
    return apiClientService.get(endpoint + FILTER_ENDPOINT, params);
  },
  getFilterOption() {
    return apiClientService.get(endpoint + FILTER_OPTION_ENDPOINT);
  },
  getSilier() {
    return apiClientService.get(endpoint + SILDER_ENDPONIT);
  },
  getTrending() {
    return apiClientService.get(endpoint + MOVIE_TOP_ENDPONIT);
  },
  getCategory(slug) {
    return apiClientService.find(endpoint + CATEGORY_MOVIE_ENDPONIT, slug);
  },
  getCountry(slug) {
    return apiClientService.find(endpoint + COUNTRY_MOVIE_ENDPONIT, slug);
  },
  getGenre(slug) {
    return apiClientService.find(endpoint + GENRE_MOVIE_ENDPONIT, slug);
  },
  getPaginate(url) {
    return apiClientService.getByUrl(url);
  },
  getMovie(slug) {
    return apiClientService.find(endpoint + CLIENT_MOVIE_ENDPONIT, slug);
  },
  getComments(slug) {
    return apiClientService.find(endpoint + MOVIE_COMMENT_ENDPONIT, slug);
  },
  createComments(data) {
    return apiClientService.create(endpoint + MOVIE_COMMENT_ENDPONIT, data);
  },
  deleteComments(id) {
    return apiClientService.delete(endpoint + MOVIE_COMMENT_ENDPONIT, id);
  },
  getFavorite(id) {
    return apiClientService.find(endpoint + MOVIE_FAVORITE_ENDPONIT, id);
  },
  createFavorite(data) {
    return apiClientService.create(endpoint + MOVIE_FAVORITE_ENDPONIT, data);
  },
  checkExistFavorite(id) {
    return apiClientService.find(endpoint + CHECK_FAVORITE_ENDPONIT, id);
  },
  createView(id) {
    return apiClientService.getByUrl(`${endpoint + CREATE_VIEW_ENDPONIT}/ ${id}`);
  },
};
