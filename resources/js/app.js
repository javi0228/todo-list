import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return (
            createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue, Ziggy)
                // Handle permissions directive
                .directive("can", {
                    mounted(el, binding, vnode, prevVnode) {
                        // Permission that is allowed to see content
                        let permissionAllowed = binding.arg;
                        // User permissions
                        let permissions =
                            props.initialPage.props.auth.permissions;

                        if (!permissionAllowed) return;

                        // Check if permissionAllowed is in user permissions list
                        let found = permissions.find((permission) => {
                            return (
                                permission.replace(" ", "-") ==
                                permissionAllowed
                            );
                        });

                        // Remove element form DOM if permissionAllowed is not in user permissions
                        if (!found) {
                            vnode.el.remove();
                        }
                    },
                })
                .mount(el)
        );
    },
    progress: {
        color: "#4B5563",
    },
});

// On page load
if (
    localStorage.theme === "dark" ||
    (!("theme" in localStorage) &&
        window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
    document.documentElement.classList.add("dark");
} else {
    document.documentElement.classList.remove("dark");
}
