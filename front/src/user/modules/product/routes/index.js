import CategoryPage from "../containers/Category/CategoryPage"
import ProductPage from "../containers/Product/ProductPage"

let ProductRoutes = [
    {
        path: 'products/categories/*',
        container: CategoryPage,
    },
    {
        path: 'products/*',
        container: ProductPage,
    }
]

export default ProductRoutes