const Button = ({ type = 'submit', className, ...props }) => (
    <button
        type={type}
        className={`${className} inline-flex items-center px-3 py-2 bg-caribbean_current border border-transparent rounded-md font-semibold text-sm text-white hover:bg-caribbean_current-400 active:bg-caribbean_current focus:border-caribbean_current focus:outline-none disabled:opacity-25 transition ease-in-out duration-150`}
        {...props}
    />
)

export default Button
