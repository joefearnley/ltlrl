const InputSuccess = ({ message = '', className = '' }) => (
    <>
        {message !== '' && (
            <>
                <p
                    className={`${className} text-sm text-green-600`}
                    key={1}>
                    {message}
                </p>
            </>
        )}
    </>
)

export default InputSuccess
