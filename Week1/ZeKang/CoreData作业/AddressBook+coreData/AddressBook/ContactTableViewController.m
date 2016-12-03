

#import "ContactTableViewController.h"
#import "ContactModel.h"
#import "AddViewController.h"
#import "EditViewController.h"


@interface ContactTableViewController ()<AddViewControllerDelegate,EditViewControllerDelegate>
@property (nonatomic,strong) NSMutableArray *contactArr;
//定义一个可变数组
@end

@implementation ContactTableViewController

- (NSMutableArray *)contactArr{
   
    if (!_contactArr) {


            _contactArr = [NSMutableArray array];
        }
    
        
   
    return _contactArr;
}





- (void)viewDidLoad {
    [super viewDidLoad];
    [self clearExtraLine:self.tableView];
    
    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
    
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//#pragma mark - Table view data source
//
//- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView {
//
//    return 1;
//}
//
//
//- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
//
//    return self.contactArr.count;
//}



//- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath {
//    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"mycell"];
//    
//    ContactModel *contactModel = self.contactArr[indexPath.row];
//    
//    cell.textLabel.text = contactModel.name;
////在tableview上显示联系人的姓名
//    cell.accessoryType = UITableViewCellAccessoryDisclosureIndicator;
//    
//    return cell;
//
//}

#pragma mark - AddViewController delegate
//- (void)addContact:(AddViewController *)addVc didAddContact:(ContactModel *)contact{
//    [self.contactArr addObject:contact];
    //1.添加数据模型
    
//    [self.tableView reloadData];
    //2.刷新表视图
    
//    [NSKeyedArchiver archiveRootObject:self.contactArr toFile:ContactFilePath];
//    //3.归档
//}
#pragma mark - 去掉多余的线
-(void)clearExtraLine :(UITableView *)tableView{
    UIView *view = [[UIView alloc] init];
    view.backgroundColor =[UIColor clearColor];
    [self.tableView setTableFooterView:view];
}



#pragma mark - Navigation


- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    
    id vc = segue.destinationViewController;
    //首先，拿到目的控制器
    if ([vc isKindOfClass:[AddViewController class]]) {
        AddViewController *addVc = vc;
        addVc.delegate = self;
    //跳转到添加联系人控制器的做法
    }else if([vc isKindOfClass:[EditViewController class]]){
        EditViewController *editVc = vc;
    //跳转到编辑联系人控制器的做法
        NSIndexPath *path = [self.tableView indexPathForSelectedRow];
        editVc.contactModel = self.contactArr[path.row];
        editVc.delegate = self;
        
    }
    
    }
#pragma mark - EditVC delegate
-(void)enditViewController:(EditViewController *)editVc didSaveContact:(ContactModel *)model{
    [self.tableView reloadData];
    //刷新表视图
//    [NSKeyedArchiver archiveRootObject:self.contactArr toFile:ContactFilePath];
//    //归档
}
#pragma mark - UITableView delegate
- (void)tableView:(UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle forRowAtIndexPath:(NSIndexPath *)indexPath{
    if (editingStyle == UITableViewCellEditingStyleDelete) {
        
        [self.contactArr removeObjectAtIndex:indexPath.row];
        //1.删除数据模型
        
        [self.tableView deleteRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationTop];
        //2.刷新表视图,有一个动画效果：自动把底部单元格往上移动
        
//        [NSKeyedArchiver archiveRootObject:self.contactArr toFile:ContactFilePath];
//        //3.归档
   

        
    }
}

@end
