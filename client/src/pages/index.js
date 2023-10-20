import Head from 'next/head'
import Link from 'next/link'
import Button from '@/components/Button'
import Input from '@/components/Input'
import InputError from '@/components/InputError'
import InputSuccess from '@/components/InputSuccess'
import CopyToClipboard from '@/components/CopyToClipboard'
import axios from '@/lib/axios'
import { useAuth } from '@/hooks/auth'
import { useEffect, useState } from 'react'
import { useRouter } from 'next/router'

export default function Home() {
    const { user } = useAuth({ middleware: 'guest' })
    const [url, setUrl] = useState('')
    const [littleUrl, setLittleUrl] = useState('')
    const [errors, setErrors] = useState([])
    const [successMessage, setSuccessMessage] = useState('')
    const csrf = () => axios.get('/sanctum/csrf-cookie')

    const createUrl = async event => {
        event.preventDefault()

        await csrf()

        setErrors([])
        setSuccessMessage('')

        axios
            .post('/api/urls', { url })
            .then(response => {
                if (response.data) {
                    setSuccessMessage('URL Created Successfully')
                    setLittleUrl(response.data.data.little_url)
                }
            })
            .catch(error => {
                setErrors(error.response.data.errors)
            })
    }

    return (
        <>
            <Head>
                <title>ltlrl</title>
            </Head>

            <div className="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center sm:pt-0">
                <div className="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    {user ? (
                        <Link
                            href="/dashboard"
                            className="ml-4 text-sm text-gray-700 underline">
                            Dashboard
                        </Link>
                    ) : (
                        <>
                            <Link
                                href="/login"
                                className="text-sm text-gray-700 underline">
                                Login
                            </Link>

                            <Link
                                href="/register"
                                className="ml-4 text-sm text-gray-700 underline">
                                Register
                            </Link>
                        </>
                    )}
                </div>

                <div className="mx-auto max-w-100 sm:px-6 lg:px-8">
                    <div className="flex justify-center pt-8 sm:pt-0">
                        <article className="prose prose-zinc lg:prose-xl">
                            <h1 className="text-center">ltlrl</h1>
                            <p className="text-center">make a url little</p>
                            <form onSubmit={createUrl} className="flex">
                                <div className="flex flex-col">
                                    <Input
                                        id="url"
                                        type="text"
                                        value={url}
                                        placeholder="enter url"
                                        className="block w-80"
                                        onChange={event => setUrl(event.target.value)}
                                    />

                                    <InputError
                                        messages={errors.url}
                                        className="mt-2"
                                    />
                                </div>
                                <div className="flex flex-col">
                                    <Button className="ml-3 w-25 justify-center">Make Little</Button>
                                </div>
                            </form>
                        </article>
                    </div>
                    {littleUrl ? (
                            <div className="mt-6 flex items-center justify-between w-full p-4 space-x-4 text-gray-500 bg-white divide-x divide-gray-200 rounded-lg shadow bottom-5 left-5 dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800">
                                <span>{littleUrl}</span>
                                <CopyToClipboard copyText={littleUrl} />
                            </div>
                        ) : ('')
                    }
                </div>
            </div>
            <div id="toast-bottom-left" className="fixed flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x divide-gray-200 rounded-lg shadow bottom-5 left-5 dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800" role="alert">
                <div className="text-sm font-normal">Bottom left positioning.</div>
            </div>
        </>
    )
}
