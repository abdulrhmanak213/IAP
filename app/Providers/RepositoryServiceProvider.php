<?php

namespace App\Providers;

use App\Repositories\Contracts\IAdmin;
use App\Repositories\Contracts\IBooking;
use App\Repositories\Contracts\IConversation;
use App\Repositories\Contracts\ICookie;
use App\Repositories\Contracts\IFAQ;
use App\Repositories\Contracts\IFavorite;
use App\Repositories\Contracts\IFile;
use App\Repositories\Contracts\IFileLog;
use App\Repositories\Contracts\IFolder;
use App\Repositories\Contracts\IHeroImage;
use App\Repositories\Contracts\IMessage;
use App\Repositories\Contracts\INotification;
use App\Repositories\Contracts\IPrivacy;
use App\Repositories\Contracts\IReport;
use App\Repositories\Contracts\IReview;
use App\Repositories\Contracts\IService;
use App\Repositories\Contracts\IServiceProvider;
use App\Repositories\Contracts\ISubService;
use App\Repositories\Contracts\ISubServiceProvider;
use App\Repositories\Contracts\ISupport;
use App\Repositories\Contracts\ITerm;
use App\Repositories\Contracts\ITransaction;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\AdminRepository;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\ConversationRepository;
use App\Repositories\Eloquent\CookieRepository;
use App\Repositories\Eloquent\FAQRepository;
use App\Repositories\Eloquent\FavoriteRepository;
use App\Repositories\Eloquent\FileLogRepository;
use App\Repositories\Eloquent\FileRepository;
use App\Repositories\Eloquent\FolderRepository;
use App\Repositories\Eloquent\HeroImageRepository;
use App\Repositories\Eloquent\MessageRepository;
use App\Repositories\Eloquent\NotificationRepository;
use App\Repositories\Eloquent\PrivacyRepository;
use App\Repositories\Eloquent\ReportRepository;
use App\Repositories\Eloquent\ReviewRepository;
use App\Repositories\Eloquent\ServiceProviderRepository;
use App\Repositories\Eloquent\ServiceRepository;
use App\Repositories\Eloquent\SubServiceProviderRepository;
use App\Repositories\Eloquent\SubServiceRepository;
use App\Repositories\Eloquent\SupportRepository;
use App\Repositories\Eloquent\TermRepository;
use App\Repositories\Eloquent\TransactionRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(IFile::class, FileRepository::class);
        $this->app->bind(IFolder::class, FolderRepository::class);
        $this->app->bind(IFileLog::class, FileLogRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
