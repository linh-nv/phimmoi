import { apiService } from "@/services/apiService";
import { ENUM_ENDPONIT } from "@/utils/apisDomain";
import { ENUM_STATUS_ENDPONIT } from "@/utils/apisDomain";
import { ENUM_MOVIE_TYPE_ENDPONIT } from "@/utils/apisDomain";
import { ENUM_MOVIE_QUALITY_ENDPONIT } from "@/utils/apisDomain";
import { ENUM_MOVIE_STATUS_ENDPONIT } from "@/utils/apisDomain";

export const enumService = {
  getAll() {
    return apiService.get(ENUM_ENDPONIT);
  },

  getStatus() {
    return apiService.get(ENUM_STATUS_ENDPONIT);
  },

  getMovieQuality() {
    return apiService.get(ENUM_MOVIE_QUALITY_ENDPONIT);
  },

  getMovieStatus() {
    return apiService.get(ENUM_MOVIE_STATUS_ENDPONIT);
  },

  getMovieType() {
    return apiService.get(ENUM_MOVIE_TYPE_ENDPONIT);
  },
};
