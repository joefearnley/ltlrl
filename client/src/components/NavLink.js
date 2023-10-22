import Link from 'next/link'

const NavLink = ({ active = false, children, ...props }) => (
    <Link
        {...props}
        className={`inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out ${
            active
                ? 'border-caribbean_current text-dark_slate_gray focus:border-caribbean_current'
                : 'border-transparent text-dark_slate_gray hover:text-dark_slate_gray-700 hover:border-caribbean_current focus:text-dark_slate_gray focus:border-dark_slate_gray-300'
        }`}>
        {children}
    </Link>
)

export default NavLink
