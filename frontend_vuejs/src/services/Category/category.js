import { apiService } from "@/services/apiService";
import { CATEGORY_ENDPONIT } from "@/utils/apisDomain";

const endpoint = CATEGORY_ENDPONIT;

export const categoryService = {
  getAll(page) {
    return apiService.getAll(endpoint, page);
  },

  search(keyword) {
    return apiService.search(endpoint, keyword);
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
