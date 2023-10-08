import Head from 'next/head'
import Link from 'next/link'
import Button from '@/components/Button'
import Input from '@/components/Input'
import InputError from '@/components/InputError'
import { useAuth } from '@/hooks/auth'
import { useEffect, useState } from 'react'
import { useRouter } from 'next/router'

export default function Home() {
    const { user } = useAuth({ middleware: 'guest' })
    const [url, setUrl] = useState('')

    const createUrl = async event => {
        console.log('creating URL....')

        await csrf()

        setErrors([])
        setStatus(null)

        axios
            .post('/url/', props)
            .then(() => mutate())
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

                <div className="mx-auto max-w-full sm:px-6 lg:px-8">
                    <div className="flex justify-center pt-8 sm:pt-0">
                        <article className="prose prose-zinc lg:prose-xl text-center">
                            <h1>ltlrl</h1>
                            <p>make a url little</p>
                            <form onSubmit={createUrl} className="flex">
                                <Input
                                    id="url"
                                    type="text"
                                    value={url}
                                    placeholder="enter url"
                                    className="block mt-1 w-full"
                                    onChange={event => setUrl(event.target.value)}
                                />
                                <Button className="ml-3 w-full justify-center">Make Little</Button>
                            </form>
                        </article>
                    </div>
                </div>
            </div>
        </>
    )
}
