import { createRouter, createWebHistory } from "vue-router";
import SubscriberList from "./components/subscriber/SubscriberList.vue";
import SubscriberView from "./components/subscriber/SubscriberView.vue";
import HomepageViewVue from "./components/HomepageView.vue";

const routes = [
  { path: "/", component: HomepageViewVue, meta: { title: "Home" } },
  {
    path: "/subscribers",
    component: SubscriberList,
    meta: { title: "Subscribers" },
  },
  {
    path: "/subscribers/:email",
    component: SubscriberView,
    props: true,
    meta: { title: "Subscriber Detail" },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const mainTitle = "Mailerlite web";
  document.title = `${mainTitle} - ${to.meta.title}`;
  next();
});

export default router;
