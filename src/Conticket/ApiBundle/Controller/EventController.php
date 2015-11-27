<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */
namespace Conticket\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;

use Conticket\ApiBundle\Handler\EventHandler;
use Conticket\ApiBundle\Form\Type\EventType;

final class EventController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var EventHandler
     */
    private $handler;

    /**
     * @param EventHandler $handler
     */
    public function __construct(EventHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * List all events.
     *
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many pages to return.")
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pages.")
     *
     * @param int $limit
     * @param int $offset
     *
     * @return string[]|string[][]
     */
    public function cgetAction($limit, $offset)
    {
        return $this->handler->all($limit, $offset);
    }

    /**
     * List an event
     *
     * @param mixed $id
     *
     * @return array
     */
    public function getAction($id)
    {
        return $this->getOr404($id);
    }

    /**
     * Create an event
     *
     * @param Request $request
     *
     * @return \FOS\RestBundle\View\View
     */
    public function postAction(Request $request)
    {
        $data = $request->request->all();
        $form = new EventType();

        $post = $this->handler->post($form, $data);

        return $this->routeRedirectView('get_event', ['id' => $post->getId()]);
    }

    /**
     * Update an event
     *
     * @param Request $request
     * @param mixed $id
     *
     * @return \FOS\RestBundle\View\View
     */
    public function putAction(Request $request, $id)
    {
        $data       = $request->request->all();
        $data['id'] = $id;

        $document = $this->handler->put(
            $this->getOr404($id),
            EventType(),
            $data
        );

        return $this->routeRedirectView(
            'get_event',
            ['id' => $document->getId()],
            Codes::HTTP_NO_CONTENT
        );
    }

    /**
     * Fetch a Event or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return DocumentInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($event = $this->handler->find($id))) {
            throw new NotFoundHttpException(sprintf('The resource "%s" was not found.', $id));
        }

        return $event;
    }
}
