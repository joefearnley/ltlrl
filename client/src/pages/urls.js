import useSWR from 'swr'
import axios from '@/lib/axios'
import { useEffect, useState } from 'react'
import AppLayout from '@/components/Layouts/AppLayout'
import Head from 'next/head'

const Urls = () => {
    const [urls, setUrls] = useState([])
    const [isLoading, setLoading] = useState(true)

    const csrf = () => axios.get('/sanctum/csrf-cookie')

    useEffect(() => {
        csrf()

        axios
            .get('/api/urls')
            .then(response => {
                console.log(`response`);
                console.log(response);

                // setUrls(response.data.urls)
                // setLoading(false)
          })
          .catch(error => console.log(error))
    }, [])

    return (
        <AppLayout
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Urls
                </h2>
            }>
            <Head>
                <title>ltlrl - Urls</title>
            </Head>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <h1>Urls</h1>
                        </div>
                    </div>
                </div>
            </div>

            {urls.map((url, index) => (
            <div className="py-12" key={index}>
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <h2>{url.title}</h2>
                            <h2>{url.url}</h2>
                        </div>
                    </div>
                </div>
            </div>
            ))}
        </AppLayout>
    )
}

export default Urls
