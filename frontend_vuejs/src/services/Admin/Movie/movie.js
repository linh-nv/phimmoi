import { apiService } from "@/services/apiService";
import { MOVIE_ENDPONIT } from "@/utils/apisDomain";

const endpoint = MOVIE_ENDPONIT;

export const movieService = {
  getAll(page) {
    return apiService.getAll(endpoint, page);
  },

  search(keyword) {
    return apiService.search(endpoint, keyword);
  },

  create(data) {
    return apiService.create(endpoint, data);
  },

  update(slug, data) {
    return apiService.updateMovie(endpoint, slug + "?method=PUT", data);
  },

  find(slug) {
    return apiService.find(endpoint, slug);
  },

  delete(slug) {
    return apiService.delete(endpoint, slug);
  },
};
