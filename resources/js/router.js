import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Home from './views/Home'
import Orders from './views/Orders'
import Products from './views/Products'
import AddProduct from './views/AddProduct'
import EditProduct from './views/EditProduct'
import Suppliers from "./views/Suppliers";
import AddSupplier from "./views/AddSupplier";
import EditSupplier from "./views/EditSupplier";
import AddOrder from "./views/AddOrder"
import EditOrder from "./views/EditOrder"

let routes = [
    {
        path: "/",
        component: Home
    },
    {
        path: "/home",
        name: "home",
        component: Home,
    },
    {
        path: "/orders",
        name: "orders",
        component: Orders
    },
    {
        path: "/products",
        name: "products",
        component: Products
    },
    {
        path: "/products/add",
        name: "add-product",
        component: AddProduct
    },
    {
        path: '/products/edit/:productId',
        name: 'edit-product',
        component: EditProduct
    },
    {
        path: "/suppliers",
        name: "suppliers",
        component: Suppliers
    },
    {
        path: "/suppliers/add",
        name: "add-supplier",
        component: AddSupplier
    },
    {
        path: '/suppliers/edit/:supplierId',
        name: 'edit-supplier',
        component: EditSupplier
    },
    {
        path: "/orders/add",
        name: "add-order",
        component: AddOrder
    },
    {
        path: '/orders/edit/:orderId',
        name: 'edit-order',
        component: EditOrder
    }
];

const router = new VueRouter({
    // mode: "history",
    linkActiveClass: 'active',
    // linkExactActiveClass: "active",
    routes: routes,
    scrollBehavior (to, from, savedPosition) {
        // Ensure that the page scrolls to the top after changing the route
        return { x: 0, y: 0 }
    }
})

export default router
