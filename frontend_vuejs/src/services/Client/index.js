import { apiService } from "@/services/apiService";
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
    return apiService.get(endpoint + headerEndponit);
  },
  search(keyword) {
    return apiService.search(endpoint + searchEndponit, keyword);
  },
  getHome() {
    return apiService.get(endpoint);
  },
  getSilier() {
    return apiService.get(endpoint + '/slider');
  },
  getTrending() {
    return apiService.get(endpoint + '/movie-top');
  },
};
