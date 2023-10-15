const InputSuccess = ({ message = '', className = '' }) => (
    <>
        {message !== '' && (
            <>
                <p
                    className={`${className} text-sm text-green-600`}
                    key={index}>
                    {message}
                </p>
            </>
        )}
    </>
)

export default InputSuccess
