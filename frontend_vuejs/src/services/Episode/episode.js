import { apiService } from "@/services/apiService";
import { EPISODE_ENDPONIT, EPISODE_MOVIE_ENDPONIT } from "@/utils/apisDomain";

const endpoint = EPISODE_ENDPONIT;

export const episodeService = {
  getByMovie(movieSlug, page) {
    return apiService.getAll(EPISODE_MOVIE_ENDPONIT + movieSlug, page);
  },

  getAll(page) {
    return apiService.getAll(endpoint, page);
  },

  create(data) {
    return apiService.create(endpoint, data);
  },

  update(id, data) {
    return apiService.update(endpoint, id, data);
  },

  find(id) {
    return apiService.find(endpoint, id);
  },

  delete(id) {
    return apiService.delete(endpoint, id);
  },

  pluck() {
    return apiService.pluck(endpoint);
  },
};
