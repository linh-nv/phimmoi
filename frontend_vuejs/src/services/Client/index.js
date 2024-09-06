import { apiService } from "@/services/apiService";
import { CLIENT_API_BASE_URL, HEADER_ENDPONIT } from "@/utils/apisDomain";

const endpoint = CLIENT_API_BASE_URL;
const headerEndponit = HEADER_ENDPONIT;

export const clientService = {
  getHeader() {
    return apiService.get(endpoint + headerEndponit);
  },
};
