import { apiClientService } from "./apiClientService";
import {
  CLIENT_API_BASE_URL,
  HEADER_ENDPONIT,
  SEARCH_ENDPONIT,
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
    return apiClientService.get(endpoint + "/filter", params);
  },
  getFilterOption() {
    return apiClientService.get(endpoint + "/filter-option");
  },
  getSilier() {
    return apiClientService.get(endpoint + "/slider");
  },
  getTrending() {
    return apiClientService.get(endpoint + "/movie-top");
  },
  getCategory(slug) {
    return apiClientService.find(endpoint + "/category", slug);
  },
  getCountry(slug) {
    return apiClientService.find(endpoint + "/country", slug);
  },
  getGenre(slug) {
    return apiClientService.find(endpoint + "/genre", slug);
  },
  getPaginate(url) {
    return apiClientService.getByUrl(url);
  },
  getMovie(slug) {
    return apiClientService.find(endpoint + "/movie", slug);
  },
  getComments(slug) {
    return apiClientService.find(endpoint + "/comment", slug);
  },
  createComments(data) {
    return apiClientService.create(endpoint + "/comment", data);
  },
  deleteComments(id) {
    return apiClientService.delete(endpoint + "/comment", id);
  },
};
