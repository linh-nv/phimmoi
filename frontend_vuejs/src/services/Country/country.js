import { apiService } from "@/services/apiService";
import { COUNTRY_ENDPONIT } from "@/utils/apisDomain";

const endpoint = COUNTRY_ENDPONIT;

export const countryService = {
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
