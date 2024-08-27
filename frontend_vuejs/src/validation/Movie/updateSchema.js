import * as yup from "yup";

export const updateSchema = yup.object({
  name: yup.string().max(255).required("Name is required"),
  slug: yup.string().max(255).required("Slug is required"),
  origin_name: yup.string().max(255).required("Origin name is required"),
  content: yup.string().required("Content is required"),
  type: yup.number().oneOf([0, 1, 2, 3]).required("Type is required"),
  status: yup.number().oneOf([0, 1, 2]).required("Status is required"),
  poster: yup.mixed().nullable(),
  thumb: yup.mixed().nullable(),
  trailer_url: yup.string().max(255).nullable(true),
  time: yup.string().max(255).nullable(true),
  episode_current: yup.string().max(255).nullable(true),
  episode_total: yup.number().nullable(true),
  quality: yup.number().oneOf([1, 2, 3]).nullable(true),
  lang: yup.string().max(255).nullable(true),
  notify: yup.string().max(255).nullable(true),
  showtimes: yup.string().max(255).nullable(true),
  year: yup
    .number()
    .min(1900)
    .max(new Date().getFullYear())
    .required("Year is required"),
  actor: yup
    .array()
    .of(yup.string().max(255))
    .min(1, "At least one actor is required"),
  director: yup
    .array()
    .of(yup.string().max(255))
    .min(1, "At least one director is required"),
  genre_ids: yup.array().of(yup.number().integer().min(1)).nullable(true),
  country_id: yup.number().required(),
  category_id: yup.number().required(),
});
