import { apiService } from "@/services/apiService";
import {
  CLIENT_API_BASE_URL,
  HEADER_ENDPONIT,
  SEARCH_ENDPONIT,
} from "@/utils/apisDomain";
import axios from "axios";

const endpoint = CLIENT_API_BASE_URL;
const headerEndponit = HEADER_ENDPONIT;
const searchEndponit = SEARCH_ENDPONIT;

export const clientService = {
  getHeader() {
    return apiService.get(endpoint + headerEndponit);
  },
  search(keyword) {
    return apiService.search(endpoint + searchEndponit, keyword);
  },
  getHome() {
    return apiService.get(endpoint);
  },
  getMovieFilter(params) {
    return apiService.get(endpoint + '/filter', params);
  },
  getFilterOption() {
    return apiService.get(endpoint + '/filter-option');
  },
  getSilier() {
    return apiService.get(endpoint + '/slider');
  },
  getTrending() {
    return apiService.get(endpoint + '/movie-top');
  },
  getCategory(slug) {
    return apiService.find(endpoint + '/category', slug);
  },
  getCountry(slug) {
    return apiService.find(endpoint + '/country', slug);
  },
  getGenre(slug) {
    return apiService.find(endpoint + '/genre', slug);
  },
  getByUrl(url) {
    return axios.get(url);
  },
};
